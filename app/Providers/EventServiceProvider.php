<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Providers;

use App\Events\Client\ClientWasCreated;
use App\Events\Invoice\InvoiceWasCreated;
use App\Events\Invoice\InvoiceWasMarkedSent;
use App\Events\Invoice\InvoiceWasUpdated;
use App\Events\Payment\PaymentWasCreated;
use App\Events\User\UserCreated;
use App\Events\User\UserLoggedIn;
use App\Listeners\Activity\CreatedClientActivity;
use App\Listeners\Activity\PaymentCreatedActivity;
use App\Listeners\Invoice\CreateInvoiceActivity;
use App\Listeners\Invoice\CreateInvoiceInvitations;
use App\Listeners\Invoice\UpdateInvoiceActivity;
use App\Listeners\SendVerificationNotification;
use App\Listeners\User\UpdateUserLastLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserCreated::class => [
            SendVerificationNotification::class,
        ],
        UserLoggedIn::class => [
            UpdateUserLastLogin::class,
        ],
        // Clients
        ClientWasCreated::class => [
            CreatedClientActivity::class,
           // 'App\Listeners\SubscriptionListener@createdClient',
        ],
        PaymentWasCreated::class => [
            PaymentCreatedActivity::class,
        ],
        'App\Events\ClientWasArchived' => [
            'App\Listeners\ActivityListener@archivedClient',
        ],
        'App\Events\ClientWasUpdated' => [
            'App\Listeners\SubscriptionListener@updatedClient',
        ],
        'App\Events\ClientWasDeleted' => [
            'App\Listeners\ActivityListener@deletedClient',
            'App\Listeners\SubscriptionListener@deletedClient',
            'App\Listeners\HistoryListener@deletedClient',
        ],
        'App\Events\ClientWasRestored' => [
            'App\Listeners\ActivityListener@restoredClient',
        ],

        //Invoices
        
        InvoiceWasMarkedSent::class => [
            CreateInvoiceInvitations::class,
        ],
        InvoiceWasUpdated::class => [
            UpdateInvoiceActivity::class,
        ],
        InvoiceWasCreated::class => [
            CreateInvoiceActivity::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        parent::boot();

    }
}
