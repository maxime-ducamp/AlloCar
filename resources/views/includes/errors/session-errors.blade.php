<div class="mt-5" id="errors-container">
    @if ($errors->any())
        <div class="bg-red-light text-white">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="py-4">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
