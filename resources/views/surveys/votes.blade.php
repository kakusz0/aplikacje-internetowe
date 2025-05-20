@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4 text-violet-800">
            Głosy w ankiecie: {{ $survey->title }}
        </h1>

        @if ($respondents->count() == 0)
            <p class="italic text-gray-500">Brak odpowiedzi na tę ankietę.</p>
        @else
            <div class="overflow-x-auto rounded bg-white shadow">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-violet-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">Respondent</th>
                            <th class="px-4 py-2 text-left font-semibold">Wybrane opcje</th>
                            <th class="px-4 py-2 text-left font-semibold">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($respondents as $respondent)
                            <tr class="hover:bg-violet-50 transition">
                                <td class="px-4 py-2">
                                    @if ($survey->is_named)
                                        {{ $respondent->user->first_name ?? 'Brak' }}
                                        {{ $respondent->user->last_name ?? '' }}
                                        <span class="text-xs text-gray-400">({{ $respondent->user->email ?? '' }})</span>
                                    @else
                                        Gość ({{ \Illuminate\Support\Str::limit($respondent->session_token, 8) }})
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $answers = $respondent->answers->where('question_id', $question->id)->first();
                                    @endphp
                                    @if ($answers)
                                        {{ $answers->answerOptions->pluck('option.option_text')->join(', ') }}
                                    @else
                                        brak odpowiedzi
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ $respondent->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="inline-block mt-8 text-violet-800 hover:underline">&larr; Wróć do panelu
        </a>
    </div>
@endsection
