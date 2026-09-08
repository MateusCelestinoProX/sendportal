<?php

declare(strict_types=1);

namespace App\Providers;

use App\Livewire\Setup;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use RuntimeException;
use Sendportal\Base\Facades\Sendportal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\URL::forceScheme("https");
        request()->setTrustedProxies(["*"], \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR | \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST | \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT | \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO);
        Paginator::useBootstrap();

        Sendportal::setCurrentWorkspaceIdResolver(
            static function () {
                /** @var User $user */
                $user = auth()->user();
                $request = request();
                $workspaceId = null;

                if ($user && $user->currentWorkspaceId()) {
                    $workspaceId = $user->currentWorkspaceId();
                } elseif ($request && (($apiToken = $request->bearerToken()) || ($apiToken = $request->get('api_token')))) {
                    $workspaceId = ApiToken::resolveWorkspaceId($apiToken);
                }

                if (! $workspaceId) {
                    throw new RuntimeException('Current Workspace ID Resolver must not return a null value.');
                }

                return $workspaceId;
            }
        );

        Sendportal::setSidebarHtmlContentResolver(
            static function () {
                return view('layouts.sidebar.manageUsersMenuItem')->render();
            }
        );

        Sendportal::setHeaderHtmlContentResolver(
            static function () {
                return view('layouts.header.userManagementHeader')->render();
            }
        );

        Livewire::component('setup', Setup::class);

        // Registro da Resend com Pool Multi-Key no SendPortal
        \Sendportal\Base\Factories\MailAdapterFactory::$adapterMap[8] = \App\Adapters\ResendMailAdapter::class;

        try {
            $ref = new \ReflectionProperty(\Sendportal\Base\Models\EmailServiceType::class, 'types');
            $ref->setAccessible(true);
            $types = $ref->getValue();
            $types[8] = 'Resend';
            $ref->setValue(null, $types);
        } catch (\Throwable $e) {
            // Log or fallback
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('sendportal_email_service_types')) {
                \Illuminate\Support\Facades\DB::table('sendportal_email_service_types')->updateOrInsert(
                    ['id' => 8],
                    [
                        'name' => 'Resend',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } catch (\Throwable $e) {
            // Ignora caso migrations não tenham rodado ainda
        }

        try {
            \Illuminate\Support\Facades\Route::middleware(['web', 'auth', \App\Http\Middleware\RequireWorkspace::class])->group(function () {
                \Illuminate\Support\Facades\Route::get('resend-keys', function () {
                    $workspaceId = \Sendportal\Base\Facades\Sendportal::currentWorkspaceId();
                    $service = \Sendportal\Base\Models\EmailService::where('workspace_id', $workspaceId)
                        ->where('type_id', 8)
                        ->first();

                    if (! $service) {
                        $service = \Sendportal\Base\Models\EmailService::where('workspace_id', $workspaceId)->first();
                    }

                    if ($service) {
                        return redirect()->route('sendportal.email_services.edit', $service->id);
                    }

                    return redirect()->route('sendportal.email_services.create');
                })->name('resend.keys');
            });
        } catch (\Throwable $e) {
            // Ignora caso rotas já tenham sido registradas
        }
    }
}
