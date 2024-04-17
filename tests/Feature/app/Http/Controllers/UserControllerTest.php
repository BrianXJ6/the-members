<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\{
    User,
    Admin,
    Topic,
    Message,
};

use Illuminate\Foundation\Testing\{
    WithFaker,
    RefreshDatabase,
};

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * List all topics that the logged in user is subscribed
     *
     * @return void
     */
    public function test_topic_list_flow(): void
    {
        $user = User::factory()
            ->has(Topic::factory()->count(3)->for(Admin::factory()->create()))
            ->create();

        $this->actingAs($user, 'user')
            ->withoutExceptionHandling()
            ->getJson(route('api.users.topics.list'))
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['*' => ['id', 'name', 'created_by', 'created_at']]])
            ->assertJson(function (AssertableJson $json) {
                $json->whereAllType(
                    ['data' => 'array'],
                    ['data.*.id' => 'integer'],
                    ['data.*.name' => 'string'],
                    ['data.*.created_by' => 'string'],
                    ['data.*.created_at' => 'string'],
                );
            });
    }

    /**
     * List messages from a subscribed topic with logged in Users
     *
     * @return void
     */
    public function test_message_list_flow(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->for(Admin::factory()->create())->hasAttached($user)->create();
        Message::factory()->for($user, 'messageable')->for($topic)->count(5)->create();

        $this->actingAs($user, 'user')
            ->withoutExceptionHandling()
            ->getJson(route('api.users.topics.messages.list', ['topic' => $topic->id]))
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['*' => ['id', 'text', 'created_at']]])
            ->assertJson(function (AssertableJson $json) {
                $json->whereAllType(
                    ['data' => 'array'],
                    ['data.*.id' => 'integer'],
                    ['data.*.text' => 'string'],
                    ['data.*.created_at' => 'string'],
                );
            });;
    }

    /**
     * Send message with user logged in to a specific topic
     *
     * @return void
     */
    public function test_send_message_flow(): void
    {
        $topic = Topic::factory()->forAdmin()->create();
        $user = User::factory()->hasAttached($topic)->create();

        $this->actingAs($user, 'user')
            ->withoutExceptionHandling()
            ->postJson(
                route('api.users.topics.messages.send', ['topic' => $topic->id]),
                ['message' => $this->faker->text()]
            )
            ->assertCreated();
    }
}
