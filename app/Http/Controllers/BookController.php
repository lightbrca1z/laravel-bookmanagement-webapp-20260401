<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class BookController extends Controller
{
    private const PER_PAGE_DEFAULT = 10;

    /** @var list<int> */
    private const PER_PAGE_OPTIONS = [10, 25, 50];

    /** @var list<string> */
    private const SORT_KEYS = ['category', 'id', 'title', 'author', 'price', 'published_at', 'created_at'];

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $sort = $this->normalizeSort((string) $request->query('sort', 'category'));
        $dir = $this->normalizeDir((string) $request->query('dir', 'asc'));
        $perPage = $this->resolvePerPage($request);

        try {
            $query = Book::query()
                ->where('user_id', $request->user()->id)
                ->with('category');
            $this->applySorting($query, $sort, $dir);

            if ($q !== '') {
                $like = '%'.$this->escapeLike($q).'%';
                $isbnDigits = preg_replace('/\D/', '', $q) ?? '';

                $query->where(function ($sub) use ($like, $isbnDigits) {
                    $sub->where('books.title', 'like', $like)
                        ->orWhere('books.author', 'like', $like);

                    if ($isbnDigits !== '') {
                        $sub->orWhere('books.isbn', 'like', '%'.$this->escapeLike($isbnDigits).'%');
                    }

                    $sub->orWhereHas('category', function ($c) use ($like) {
                        $c->where('title', 'like', $like);
                    });
                });
            }

            $books = $query->paginate($perPage)->withQueryString();
        } catch (\Throwable $e) {
            \Log::error('Book index: '.$e->getMessage());

            $books = new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
                'pageName' => 'page',
            ]);

            return view('books.index', [
                'books' => $books,
                'searchQuery' => $q,
                'sort' => $sort,
                'dir' => $dir,
                'perPage' => $perPage,
                'perPageOptions' => self::PER_PAGE_OPTIONS,
            ])->with('error', 'データの取得中にエラーが発生しました。');
        }

        return view('books.index', [
            'books' => $books,
            'searchQuery' => $q,
            'sort' => $sort,
            'dir' => $dir,
            'perPage' => $perPage,
            'perPageOptions' => self::PER_PAGE_OPTIONS,
        ]);
    }

    private function resolvePerPage(Request $request): int
    {
        $v = (int) $request->query('per_page', self::PER_PAGE_DEFAULT);

        return in_array($v, self::PER_PAGE_OPTIONS, true) ? $v : self::PER_PAGE_DEFAULT;
    }

    private function normalizeSort(string $sort): string
    {
        return in_array($sort, self::SORT_KEYS, true) ? $sort : 'category';
    }

    private function normalizeDir(string $dir): string
    {
        return strtolower($dir) === 'desc' ? 'desc' : 'asc';
    }

    private function applySorting(Builder $query, string $sort, string $dir): void
    {
        if ($sort === 'category') {
            $query->leftJoin('categories', 'books.category_id', '=', 'categories.id')
                ->select('books.*')
                ->orderBy('categories.title', $dir)
                ->orderBy('books.title', 'asc');

            return;
        }

        $query->orderBy('books.'.$sort, $dir)
            ->orderBy('books.id', 'asc');
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $value);
    }

    public function show(Book $book): View
    {
        $book->load('category');

        return view('books.show', compact('book'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('title')->get();

        return view('books.create', compact('categories'));
    }

    public function edit(Book $book): View
    {
        $categories = Category::orderBy('title')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    public function store(BookPostRequest $request): RedirectResponse
    {
        Book::create([
            ...$request->only([
                'category_id',
                'title',
                'author',
                'isbn',
                'price',
                'published_at',
                'description',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('books.index')->with('success', '書籍を登録しました。');
    }

    public function update(BookPostRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->only([
            'category_id',
            'title',
            'author',
            'isbn',
            'price',
            'published_at',
            'description',
        ]));

        return redirect()->route('books.show', $book)->with('success', '書籍を更新しました。');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', '書籍を削除しました。');
    }
}
