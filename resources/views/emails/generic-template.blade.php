{{-- Hapus x-layout jika tidak diperlukan --}}
<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailData['title'] ?? 'Email Notification' }}</title>
    <style>
        .email-container { max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; }
        .email-header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .email-body { padding: 30px; line-height: 1.6; }
        .email-details { margin-top: 20px; background: #f8f9fa; padding: 15px; border-radius: 5px; }
        .detail-item { margin: 10px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $emailData['title'] ?? 'Notifikasi Sistem' }}</h1>
        </div>

        <!-- Konten Utama -->
        <div class="email-body">
            @if(isset($emailData['greeting']))
                <p class="greeting">{{ $emailData['greeting'] }}</p>
            @endif

            <div class="email-content">
                {!! $emailData['message'] ?? '' !!}
            </div>

            @if(isset($emailData['data']))
                <div class="email-details">
                    @foreach($emailData['data'] as $label => $value)
                        <div class="detail-item">
                            <strong>{{ $label }}:</strong>
                            <span>{!! $value !!}</span> 
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>