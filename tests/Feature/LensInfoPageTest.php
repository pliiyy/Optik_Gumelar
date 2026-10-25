<?php

namespace Tests\Feature;

use Tests\TestCase;

class LensInfoPageTest extends TestCase
{
    public function test_info_lensa_page_explains_each_lens_and_uses_matching_headings(): void
    {
        $response = $this->get('/info-lensa');

        $response->assertOk()
            ->assertSee('Info Lensa')
            ->assertSee('Kenali Pilihan Lensa Kacamata')
            ->assertSee('Single Vision Standard')
            ->assertSee('Anti Radiasi Blue Light')
            ->assertSee('Photochromic (Transisi)')
            ->assertSee('Progressive Multifocal')
            ->assertSee('Soft Contact Lens Bening')
            ->assertSee('Contact Lens Silicone Hydrogel')
            ->assertSee('Lapisan Anti Gores')
            ->assertSee('Lapisan Anti Air & Minyak')
            ->assertDontSee('Kirim Pesan');

        $this->get('/kontak')->assertNotFound();
    }
}
