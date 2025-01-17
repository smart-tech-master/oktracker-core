<x-app-layout>
    @section('title', 'Edit Series')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('series.index') }}" class="font-normal cursor-pointer hover:underline">{{ __('Series') }}</a> / <span class="font-normal">{{ __('Edit') }} </span>/ {{ $series->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-jet-action-section title="Pointers" description="Follow the indications below with care. <br><br>
            <b>Title</b> - Only change it if theres something severly wrong. Make sure there are no volume numbers and no () or other info such as '(light novel) (paperback)' etc. <br><br>
            <b>Summary</b> - It supports HTML markup for bolding, italics and underlines.<br><br>
            <b>Authors</b> - Includes authors and artists or other contributors that worked on the original book (Does not include translators, editors etc.). Separate names with a ','. When working with a foreign book, write the name in the english alphabet if possible (i.e. 暁なつめ will be written as Natsume Akatsuki)<br><br>
            <b>Cover</b> - If the series has more than one volumes, use the Vol.1 cover. Get the highest quality possible thats under 2mb in filesize.">
                <x-slot name="content">

                    <form action="{{ route('series.update', ['series' => $series->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input required name="title" placeholder="E.g. Monkey High" type="text" class="mt-1 block w-full" autocomplete="title" value="{{ $series->title }}" />
                            <x-jet-input-error for="title" class="mt-2" />
                        </div>

                        <div class="mt-2">
                            <x-jet-label for="summary" value="{{ __('Summary') }} ({{ __('Optional') }})" />
                            <textarea name="summary" id="summary" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices nibh ut justo auctor mollis. Nulla varius consectetur nunc, sed dapibus diam." class="w-full placeholder:italic border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{!! $series->summary !!}</textarea>
                        </div>

                        <div class="mt-2 flex">
                            <!-- <div class="w-1/4 mr-1">
                                <x-jet-label for="publisher"
                                    value="{{ __('Publisher') }} ({{ __('Optional') }})" />
                                <x-jet-input name="publisher" placeholder="E.g. Kodansha" type="text"
                                    class="mt-1 block w-full" autocomplete="publisher"
                                    value="{{ $series->publisher }}" />
                                <x-jet-input-error for="publisher" class="mt-2" />
                            </div>
                            <div class="w-1/4 mx-1">
                                <x-jet-label for="language" value="{{ __('Language') }}" />
                                <x-jet-input required name="language" placeholder="E.g. en_US" type="text"
                                    class="mt-1 block w-full" autocomplete="language"
                                    value="{{ $series->language }}" />
                                <x-jet-input-error for="language" class="mt-2" />
                            </div> -->
                            <div class="w-full ml-1">
                                <x-jet-label for="authors" value="{{ __('Authors') }} ({{ __('Optional') }})" />
                                <x-jet-input name="authors" placeholder="E.g. Seiso, Mark" type="text" class="mt-1 block w-full" autocomplete="authors" value="{{ $series->authors != null ? implode(', ', json_decode($series->authors)) : '' }}" />
                                <x-jet-input-error for="authors" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-2">
                            <x-jet-label for="contributions" value="{{ __('Cover Photo') }} ({{ __('Optional') }})" />
                            <div onclick="openInput()" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                @if ($series->cover_url != '/missing_cover.png')
                                <img src="{{ $series->cover_url }}" alt="preview" id="cover-preview" class="max-h-64">
                                @else
                                <img src="" alt="preview" id="cover-preview" class="hidden max-h-64">
                                @endif
                                <div id="empty_file_input" class="space-y-1 text-center {{ $series->cover_url != '/missing_cover.png' ? 'hidden' : null }}">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex justify-center text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" onchange="handleFiles()" name="cover" type="file" class="hidden sr-only">
                                        </label>
                                        {{-- <p class="pl-1">or drag and drop</p> --}}
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, JPEG up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button class="w-full text-center py-3 bg-black text-white rounded-md">{{ __('Submit') }}</button>
                        </div>
                    </form>
                    <div class="p-2">
                        <form action="{{ route('series.destroy', ['series' => $series->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="float-right text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    </div>
    <script>
        const preview = document.getElementById('cover-preview');
        const file_input = document.getElementById('file-upload');
        const empty_file_input_data = document.getElementById('empty_file_input');

        function openInput() {
            file_input.click();
        }

        function handleFiles() {
            let [file] = file_input.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
            hideEmptyInputData();
        }

        function hideEmptyInputData() {
            empty_file_input_data.classList.add('hidden');
            preview.classList.remove('hidden');
        }
    </script>
</x-app-layout>