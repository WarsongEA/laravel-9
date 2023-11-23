<?php

namespace Tests\Feature;

use App\Dto\EmailDto;
use App\Http\Requests\SendEmailsRequest;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailSendTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @see SendEmailsRequest::rules()
     */
    public function test_send_not_valid_request(): void
    {
        $response = $this->postJson('/api/1/send', [
            'emails' => [
                [
                    'messageBody' => '',
                    'messageSubject' => '',
                    'toEmailAddress' => 'test',
                ]
            ]
        ]);

        $errors = $response->json('errors');
        $this->assertArrayHasKey('emails.0.messageBody', $errors);
        $this->assertArrayHasKey('emails.0.messageSubject', $errors);
        $this->assertArrayHasKey('emails.0.toEmailAddress', $errors);
    }


    /**
     * @see SendEmailsRequest::rules()
     */
    public function test_send_valid_request(): void
    {
        Queue::fake();

        $response = $this->postJson('/api/1/send', [
            'emails' => [
                [
                    'messageBody' => 'test',
                    'messageSubject' => 'test',
                    'toEmailAddress' => 'test@test.com',
                ]
            ]
        ]);

        $this->assertJson($response->getContent(), json_encode(['success' => true]));
    }

    public function test_it_lists_all_sent_emails()
    {
        /** @var ElasticsearchHelperInterface $elasticsearchHelper */
        $elasticsearchHelper = $this->app->make(ElasticsearchHelperInterface::class);
        $emailDto = new EmailDto(email: 'test@td.com', subject: 'test-subject', body: 'test-text');
        $elasticsearchHelper->storeEmail($emailDto);

        $response = $this->getJson('/api/list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['email', 'subject', 'body'] // Add other fields if necessary
        ]);
    }
}
