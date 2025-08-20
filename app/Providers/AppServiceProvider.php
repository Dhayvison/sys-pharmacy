<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (User $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verificação de e-mail - ' . config('app.name'))
                ->greeting("Olá! {$notifiable->name}")
                ->line('É um prazer tê-lo(a) aqui conosco.')
                ->line('Para confirmar seu cadastro, por favor, clique no link abaixo:')
                ->action('Verificar endereço de e-mail', $url)
                ->line('Se você não reconhece esta solicitação de confirmação, pode simplesmente ignorar esta mensagem. Sua segurança é importante para nós.')
                ->salutation("Atenciosamente, " . config('app.name') . ".");
        });

        ResetPassword::toMailUsing(function (User $notifiable, string $token) {
            $url  = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Redefinição de senha - ' . config('app.name'))
                ->greeting("Olá! {$notifiable->name}")
                ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para a sua conta.')
                ->line('Para prosseguir com a redefinição, por favor, clique no link abaixo:')
                ->action('Redefinir minha senha', $url)
                ->line('Este link para redefinição de senha irá expirar em ' . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . ' minutos.')
                ->line('Se você não reconhece esta solicitação de redefinição, pode simplesmente ignorar esta mensagem. Sua segurança é importante para nós.')
                ->salutation("Atenciosamente, " . config('app.name') . ".");
        });
    }
}
