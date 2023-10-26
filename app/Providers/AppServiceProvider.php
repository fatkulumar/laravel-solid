<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryImplement;
use App\Repositories\ForgotPassword\ForgotPasswordRepository;
use App\Repositories\ForgotPassword\ForgotPasswordRepositoryImplement;
use App\Repositories\SendEmail\SendEmailRepositoryImplement;
use App\Repositories\SendEmail\SendEmailRepository;
use App\Repositories\SuperAdmin\Permission\HasPermissionSuperAdminRepository;
use App\Repositories\SuperAdmin\Permission\HasPermissionSuperAdminRepositoryImplement;
use App\Repositories\SuperAdmin\Role\HasRoleSuperAdminRepository;
use App\Repositories\SuperAdmin\Role\HasRoleSuperAdminRepositoryImplement;
use App\Repositories\SuperAdmin\User\UserSuperAdminRepository;
use App\Repositories\SuperAdmin\User\UserSuperAdminRepositoryImplement;
use App\Repositories\Test\TestRepository;
use App\Repositories\Test\TestRepositoryImplement;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceImplement;
use App\Services\ForgotPassword\ForgotPasswordService;
use App\Services\ForgotPassword\ForgotPasswordServiceImplement;
use App\Services\SendEmail\SendEmailServiceImplement;
use App\Services\SendEmail\SendEmailService;
use App\Services\SuperAdmin\User\UserSuperAdminService;
use App\Services\SuperAdmin\User\UserSuperAdminServiceImplement;
use App\Services\Test\TestService;
use App\Services\Test\TestServiceImplement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TestService::class, TestServiceImplement::class);
        $this->app->bind(TestRepository::class, TestRepositoryImplement::class);

        $this->app->bind(AuthService::class, AuthServiceImplement::class);
        $this->app->bind(AuthRepository::class, AuthRepositoryImplement::class);

        $this->app->bind(SendEmailService::class, SendEmailServiceImplement::class);
        $this->app->bind(SendEmailRepository::class, SendEmailRepositoryImplement::class);

        $this->app->bind(ForgotPasswordService::class, ForgotPasswordServiceImplement::class);
        $this->app->bind(ForgotPasswordRepository::class, ForgotPasswordRepositoryImplement::class);

        $this->app->bind(UserSuperAdminService::class, UserSuperAdminServiceImplement::class);
        $this->app->bind(UserSuperAdminRepository::class, UserSuperAdminRepositoryImplement::class);

        $this->app->bind(HasRoleSuperAdminRepository::class, HasRoleSuperAdminRepositoryImplement::class);

        $this->app->bind(HasPermissionSuperAdminRepository::class, HasPermissionSuperAdminRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
