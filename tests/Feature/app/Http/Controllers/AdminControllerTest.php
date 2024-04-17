<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\{
    User,
    Admin,
    Topic,
};

use Illuminate\Foundation\Testing\{
    WithFaker,
    RefreshDatabase,
};

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class AdminControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Create a new user
     *
     * @return void
     */
    public function test_endpoint_create_user_flow(): void
    {
        $this->actingAs(Admin::factory()->newModel(), 'admin')
            ->withoutExceptionHandling()
            ->postJson(route('api.admin.create-user'), [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
            ])
            ->assertJsonStructure(['data' => ['id', 'name', 'email']])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
                'data.email' => 'string',
            ]))
            ->assertJsonIsObject()
            ->assertCreated();
    }

    /**
     * Store a newly created topic by admin in storage.
     *
     * @return void
     */
    public function test_endpoint_store_topic_flow(): void
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->postJson(route('api.admin.topics.store'), ['name' => $this->faker->word()])
            ->assertJsonStructure(['data' => ['id', 'name']])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
            ]))
            ->assertJsonIsObject()
            ->assertCreated();
    }

    /**
     * Update the specified topic in storage.
     *
     * @return void
     */
    public function test_endpoint_update_topic_flow(): void
    {
        $admin = Admin::factory()->hasTopics(1)->create();
        $topic = Topic::factory()->for($admin)->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->putJson(
                route('api.admin.topics.update', ['topic' => $topic->id]),
                ['name' => $this->faker->words(10, true)]
            )
            ->assertNoContent();
    }

    /**
     * Remove the specified topic from storage.
     *
     * @return void
     */
    public function test_endpoint_delete_topic_flow(): void
    {
        $admin = Admin::factory()->hasTopics(1)->create();
        $topic = Topic::factory()->for($admin)->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->deleteJson(route('api.admin.topics.delete', ['topic' => $topic->id]))
            ->assertNoContent();
    }

    /**
     * Subscribe user to the specific topic
     *
     * @return void
     */
    public function test_endpoint_subscribe_flow(): void
    {
        $admin = Admin::factory()->hasTopics(1)->create();
        $topic = Topic::factory()->for($admin)->create();
        $user = User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->postJson(route('api.admin.topics.users.subscribe', [
                'topic' => $topic->id,
                'user' => $user->id,
            ]))
            ->assertNoContent();
    }

    /**
     * Unsubscribe user associated with specific topic
     *
     * @return void
     */
    public function test_endpoint_unsubscribe_flow(): void
    {
        $admin = Admin::factory()->hasTopics(1)->create();
        $topic = Topic::factory()->for($admin)->create();
        $user = User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->postJson(route('api.admin.topics.users.unsubscribe', [
                'topic' => $topic->id,
                'user' => $user->id,
            ]))
            ->assertNoContent();
    }

    /**
     * Post a message to a specific topic
     *
     * @return void
     */
    public function test_endpoint_send_message_flow(): void
    {
        $admin = Admin::factory()->hasTopics(1)->create();
        $topic = Topic::factory()->for($admin)->create();

        // Testing without anyone subscribing to the topic
        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->postJson(
                route('api.admin.topics.messages.send', ['topic' => $topic->id]),
                ['message' => $this->faker->text()]
            )
            ->assertJsonStructure(['data' => ['id', 'text', 'created_at']])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType([
                'data.id' => 'integer',
                'data.text' => 'string',
                'data.created_at' => 'string',
            ]))
            ->assertJsonIsObject()
            ->assertCreated();

        // Testing with 3 users subscribed to the topic
        $topic2 = Topic::factory()->for($admin)->hasUsers(3)->create();

        $this->actingAs($admin, 'admin')
            ->withoutExceptionHandling()
            ->postJson(
                route('api.admin.topics.messages.send', ['topic' => $topic2->id]),
                ['message' => $this->faker->text()]
            )
            ->assertJsonStructure(['data' => ['id', 'text', 'created_at']])
            ->assertJson(fn (AssertableJson $json) => $json->whereAllType([
                'data.id' => 'integer',
                'data.text' => 'string',
                'data.created_at' => 'string',
            ]))
            ->assertJsonIsObject()
            ->assertCreated();
    }
}
