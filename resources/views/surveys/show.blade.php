@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow rounded p-8">
    <h2 class="text-xl font-bold text-violet-700 mb-6">{{ $survey->title }}</h2>
    <form method="POST" action="">
        @csrf
        <div class="mb-4">
            @if($question->question_type == 'single')
                @foreach($question->options as $opt)
                    <label class="block mb-1">
                        <input type="radio" name="answer" value="{{ $opt->id }}" required>
                        {{ $opt->option_text }}
                    </label>
                @endforeach
            @else
                @foreach($question->options as $opt)
                    <label class="block mb-1">
                        <input type="checkbox" name="answer[]" value="{{ $opt->id }}">
                        {{ $opt->option_text }}
                    </label>
                @endforeach
            @endif
        </div>
        <button class="bg-emerald-600 text-white px-8 py-2 rounded">Zagłosuj</button>
    </form>
</div>
@endsection