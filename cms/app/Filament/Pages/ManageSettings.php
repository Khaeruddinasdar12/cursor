<?php

namespace App\Filament\Pages;

use App\Support\SiteSettings;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?string $slug = 'pengaturan-situs';

    protected string $view = 'filament.pages.manage-settings';

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $values = collect(SiteSettings::fields())
            ->mapWithKeys(fn ($field, $key) => [$key => SiteSettings::get($key)])
            ->all();

        $this->form->fill($values);
    }

    public function form(Schema $schema): Schema
    {
        $tabs = collect(SiteSettings::groups())->map(function (array $group, string $slug) {
            return Tab::make($group['label'])
                ->key($slug)
                ->schema([
                    Section::make()
                        ->columns(2)
                        ->schema(collect($group['fields'])->map(fn ($field, $key) => $this->makeField($key, $field))->values()->all()),
                ]);
        })->values()->all();

        return $schema
            ->components([Tabs::make('Pengaturan')->tabs($tabs)->persistTabInQueryString()->columnSpanFull()])
            ->statePath('data');
    }

    protected function makeField(string $key, array $field)
    {
        $type = $field['type'] ?? 'text';

        $component = match ($type) {
            'textarea' => Textarea::make($key)->rows(3)->columnSpanFull(),
            'image' => FileUpload::make($key)->image()->imageEditor()->disk('public')->directory('settings')->maxSize(2048),
            'number' => TextInput::make($key)->numeric()->minValue(1),
            default => TextInput::make($key)->maxLength(500),
        };

        $component->label($field['label']);

        if (isset($field['help'])) {
            $component->helperText($field['help']);
        }

        return $component;
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $values = collect(SiteSettings::fields())
            ->mapWithKeys(fn ($field, $key) => [$key => $state[$key] ?? null])
            ->map(fn ($value) => is_array($value) ? (array_values($value)[0] ?? null) : $value)
            ->all();

        SiteSettings::save($values);

        Notification::make()->title('Pengaturan disimpan')->success()->send();
    }
}
