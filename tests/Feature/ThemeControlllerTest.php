<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Theme;

class ThemeControlllerTest extends TestCase
{
    /** @test */
    public function an_user_can_store_a_theme()
    {
        $theme = factory(Theme::class)->raw(['user_id' => null]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->postJson(route('themes.store'), $theme)
            ->assertSuccessful();

        $this->assertNotNull(Theme::find($response->json('id')));
    }

    /** @test */
    public function an_guest_cannot_store_a_theme()
    {
        $theme = factory(Theme::class)->make(['user_id' => null]);
        
        $this
            ->postJson(route('themes.store'), $theme->toArray())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_user_can_update_his_own_theme()
    {
        $user = factory(User::class)->create();
        $theme = factory(Theme::class)->create(['user_id' => $user->id]);
        $data = factory(Theme::class)->raw([
            'name' => 'new name',
            'description' => 'new description',
            'user_id' => null,
        ]);
        

        $this->actingAs($user)
            ->putJson(route('themes.update', $theme), $data)
            ->assertSuccessful();

        $theme->refresh();

        $this->assertEquals('new name', $theme->name);
        $this->assertEquals('new description', $theme->description);
    }

    /** @test */
    public function an_user_cannot_update_a_theme_for_other_user()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $theme = factory(Theme::class)->create(['user_id' => $user2->id]);
        $data = factory(Theme::class)->raw([
            'name' => 'new name',
            'description' => 'new description',
            'user_id' => null,
        ]);
        

        $this->actingAs($user)
            ->putJson(route('themes.update', $theme), $data)
            ->assertForbidden();
    }

    /** @test */
    public function an_user_can_delete_his_own_theme()
    {
        $user = factory(User::class)->create();
        $theme = factory(Theme::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->deleteJson(route('themes.destroy', $theme))
            ->assertSuccessful();

        $this->assertTrue($theme->fresh()->trashed());
    }

    /** @test */
    public function an_user_can_delete_other_user_theme()
    {
        $user = factory(User::class)->create();
        $theme = factory(Theme::class)->create(['user_id' => factory(User::class)->create()->id]);

        $this->actingAs($user)
            ->deleteJson(route('themes.destroy', $theme))
            ->assertForbidden();
    }
}
