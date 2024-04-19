<x-app-layout>
    <div class="pt-8">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('member.ecourses.index') }}" class="text-blue-500">My Courses</a> / <span class="">Riwayat Langganan</span>
        </div>  
    </div>
    <x-panel>
        <h1 class="font-bold text-xl text-center mb-4">Riwayat Langganan</h1>
            <table class="w-full">
                <tr>
                    <th>Course</th>
                    <th>Mulai</th>
                    <th>Akhir</th>
                    <th>#</th>
                </tr>
            @forelse ($subscriptions as $subscription)
                <tr class="my-2">
                    <td class="text-center"><a href="{{ route('ecourses.show', $subscription->ecourse->slug) }}" class="underline font-bold">{{ $subscription->ecourse->title }}</a></td>
                    <td class="text-center">{{ $subscription->start_date->format('d M Y') }}</td>
                    <td class="text-center">{{ $subscription->end_date?->format('d M Y') }}</td>
                    <td class="text-center"></td>
                </tr>
            @empty
            <tr class="text-center" colspan="4"><td>
                Anda belum berlangganan Online Course QAC, <a href="{{ route('ecourses.index') }}" class="text-blue-500 underline font-bold">Daftar Disini</a>
                </td></tr>
            @endforelse
            </table>
            {{ $subscriptions->links() }}
    </x-panel>
    
</x-app-layout>