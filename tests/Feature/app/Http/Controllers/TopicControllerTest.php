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

class TopicControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Display a listing of the topics.
     *
     * @return void
     */
    public function test_topics_endpoint_list_flow(): void
    {
        Topic::factory()->for(Admin::factory()->create())->count(3)->create();

        $this->withoutExceptionHandling()
            ->getJson(route('api.topics.list'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [],
                'data' => ['*' => ['id', 'name', 'created_by', 'created_at']]
            ])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType(
                ['data' => 'array'],
                ['data.*.id' => 'integer'],
                ['data.*.name' => 'string'],
                ['data.*.created_by' => 'string'],
                ['data.*.created_at' => 'string'],
            ));
    }

    /**
     * Display the specified topic.
     *
     * @return void
     */
    public function test_topics_endpoint_show_flow(): void
    {
        $topic = Topic::factory()->for(Admin::factory()->create())->create();

        $this->withoutExceptionHandling()
            ->getJson(route('api.topics.show', ['topic' => $topic->id]))
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['id', 'name', 'created_by', 'created_at']])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType(
                ['data' => 'array'],
                ['data.*.id' => 'integer'],
                ['data.*.name' => 'string'],
                ['data.*.created_by' => 'string'],
                ['data.*.created_at' => 'string'],
            ));
    }

    /**
     * Get list of users subscribed to a specific topic
     *
     * @return void
     */
    public function test_topics_endpoint_subscribers_flow(): void
    {
        $topic = Topic::factory()
            ->for(Admin::factory()->create())
            ->has(User::factory()->count(5))
            ->create();

        $this->withoutExceptionHandling()
            ->getJson(route('api.topics.users.subscribers', ['topic' => $topic->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [],
                'data' => ['*' => ['name', 'email']]
            ])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType(
                ['data' => 'array'],
                ['data.*.name' => 'string'],
                ['data.*.email' => 'string'],
            ));
    }

    /**
     * User subscriptions to the specific topic
     *
     * @return void
     */
    public function test_topics_endpoint_subscriptions_flow(): void
    {
        $topic = Topic::factory()
            ->for(Admin::factory())
            ->create();

        $this->withoutExceptionHandling()->postJson(
            route('api.topics.users.subscriptions', ['topic' => $topic->id]),
            ['email' => $this->faker()->safeEmail()]
        )->assertNoContent();
    }

    /**
     * Get list of messages to a specific topic
     *
     * @return void
     */
    public function test_topics_endpoint_messages_flow(): void
    {
        $topic = Topic::factory()
            ->for(Admin::factory()->create())
            ->has(Message::factory()->for(User::factory()->create(), 'messageable')->count(5))
            ->create();

        $this->withoutExceptionHandling()
            ->getJson(route('api.topics.messages.messages', ['topic' => $topic->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [],
                'data' => ['*' => ['id', 'submitted_by', 'message', 'shipped_in']],
            ])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType(
                ['data' => 'array'],
                ['data.*.id' => 'integer'],
                ['data.*.submitted_by' => 'string'],
                ['data.*.message' => 'string'],
                ['data.*.shipped_in' => 'string'],
            ));
    }
}
