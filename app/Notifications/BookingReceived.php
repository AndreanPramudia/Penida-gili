<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking->loadMissing('bookable');

        $mail = (new MailMessage)
            ->subject("Booking {$booking->reference} received — Penida Gili")
            ->greeting("Hi {$booking->customer_name},")
            ->line('Thanks for booking with Penida Gili. We have received your reservation and our team will confirm it shortly.')
            ->line("**Reference:** {$booking->reference}")
            ->line("**Product:** {$booking->product_label}")
            ->line('**Date:** '.$booking->travel_date->format('D, d M Y').($booking->check_out ? ' → '.$booking->check_out->format('D, d M Y') : ''))
            ->line("**Guests:** {$booking->guests_label}")
            ->line("**Total:** {$booking->total_label}")
            ->action('View your booking', route('bookings.show', $booking))
            ->line('Reply to this email or message us on WhatsApp if anything needs to change.');

        if ($bcc = config('penida.booking.notify_email')) {
            $mail->bcc($bcc);
        }

        return $mail;
    }
}
