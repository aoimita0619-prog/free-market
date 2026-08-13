<?php

namespace App\Providers;

use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(
        \Laravel\Fortify\Contracts\RegisterResponse::class,
        new class implements \Laravel\Fortify\Contracts\RegisterResponse
        {
            public function toResponse($request)
            {
                return redirect()->route('verification.notice');
            }
        }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        Fortify::loginView(function () {
            return view('login');
        });

        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

         Fortify::authenticateUsing(function ($request) {
          $request->validate(
          [
            'email' => ['required', 'email'],
            'password' => ['required'],
          ],
          [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは正しい形式で入力してください',
            'password.required' => 'パスワードを入力してください',
          ]
        );

         $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
              Fortify::username() => 'ログイン情報が登録されていません',
            ]);
        }

         return $user;
        });

    }
}
