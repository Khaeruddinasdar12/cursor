<?php

namespace Tests\Unit;

use App\Support\SiteSettings;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function test_month_short_uses_indonesian_abbreviations(): void
    {
        $this->assertSame('Mei', month_short(5));
        $this->assertSame('Agu', month_short(8));
        $this->assertSame('Okt', month_short(10));
        $this->assertSame('Des', month_short(12));
    }

    public function test_every_setting_has_a_label_and_defaults_cover_all_keys(): void
    {
        $fields = SiteSettings::fields();

        $this->assertNotEmpty($fields);
        $this->assertSame(array_keys($fields), array_keys(SiteSettings::defaults()));

        foreach ($fields as $key => $field) {
            $this->assertNotEmpty($field['label'], "Pengaturan {$key} tanpa label");
        }
    }
}
