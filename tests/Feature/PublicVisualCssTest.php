<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicVisualCssTest extends TestCase
{
    public function test_css_contains_wide_visual_reset_system(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertStringContainsString('--layout-wide: 1680px', $css);
        $this->assertStringContainsString('--layout-gutter: clamp(20px, 4vw, 72px)', $css);
        $this->assertStringContainsString('.home-hero--editorial', $css);
        $this->assertStringContainsString('background-image: var(--hero-image)', $css);
        $this->assertStringContainsString('.credibility-strip', $css);
        $this->assertStringContainsString('.card-grid--compact', $css);
        $this->assertStringContainsString('.logo-grid--wide', $css);
        $this->assertStringNotContainsString('linear-gradient', $css);
    }
}
