<x-app-layout>
    <div class="flex flex-wrap place-content-center min-h-48 md:min-h-screen bg-no-repeat bg-cover bg-center" 
    style="background-image: url('{{ asset('images/ecourse-banner.jpg') }}');">
    </div>
    <x-panel>
        <div class="flex flex-wrap -m-4">
            @foreach ($ecourses as $ecourse)
            <div class="md:w-1/2 p-4">
                <x-ecourse-card :ecourse="$ecourse" />
            </div>
            @endforeach
        </div>
    </x-panel>
    
</x-app-layout>