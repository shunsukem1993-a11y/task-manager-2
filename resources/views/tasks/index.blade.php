<x-app-layout>
    <x-slot name="title">タスク一覧</x-slot>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- ヘッダー --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">タスク一覧</h1>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                新規登録
            </a>
        </div>
        
        {{-- 検索エリア --}}
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                タスク検索
            </h2>

            <form action="{{ route('tasks.index') }}" method="GET">
                <div class="space-y-4">

                    {{-- タイトル検索 --}}
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700 mb-1">
                            タイトル
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            value="{{ $keyword ?? request('keyword') }}"
                            placeholder="タイトルを入力してください"
                            class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    {{-- 優先度ソート --}}
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">
                            優先度
                        </label>

                        <select
                            id="sort"
                            name="sort"
                            class="w-full border border-gray-300 rounded px-3 py-2"
                        >
                            <option value="">並び替えを選択してください</option>

                            <option value="high" {{ $sort === 'high' ? 'selected' : '' }}>
                                優先度が高い順
                            </option>

                         <option value="low" {{ $sort === 'low' ? 'selected' : '' }}>
                              優先度が低い順
                            </option>
                        </select>

                    </div>

                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                    >
                        検索
                    </button>
                </div>
            </form>
        
        {{-- 検索結果メッセージ --}}
        @if(request()->has('keyword'))
            @if(blank($keyword))
                <p>検索キーワードが入力されていないため、全件表示しています。</p>
            @elseif($tasks->isEmpty())
                <p>「{{ $keyword }}」に一致するタスクは見つかりませんでした。</p>
            @else
                <p>「{{ $keyword }}」の検索結果：{{ $tasks->count() }}件</p>
            @endif
        @endif
    </div>

        {{-- タスクリスト --}}
        @forelse($tasks as $task)
            <div class="border-b border-gray-200 py-4 last:border-b-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('tasks.show', $task) }}" class="text-gray-800 hover:text-blue-500">
                                {{ $task->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">
                            カテゴリー: {{ $task->category->name ?? '未分類' }}
                        </p>
                        <div class="flex items-center mt-2">
                            {{-- 優先度表示 --}}
                            <span class="px-2 py-1 text-xs rounded 
                                @if($task->priority === 3) bg-red-100 text-red-800
                                @elseif($task->priority === 2) bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                @if($task->priority === 3) 高
                                @elseif($task->priority === 2) 中
                                @else 低
                                @endif
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('tasks.edit', $task) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                        編集
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-8">
                タスクがありません。「新規登録」ボタンからタスクを追加してください。
            </p>
        @endforelse
    </div>
</x-app-layout>