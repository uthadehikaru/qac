Segera mulai kerjakan Quiz sebelum {{ $participant->quiz->end_date->format('d M Y') }}
<a href="{{ route('quiz.verify', $participant->session) }}">Klik disini</a> untuk memulai Quiz {{ $participant->quiz->name }}