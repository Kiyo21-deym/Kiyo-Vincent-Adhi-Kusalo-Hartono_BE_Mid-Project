<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Book;
use App\Models\BorrowingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'borrowingDetails.book'])
            ->latest()
            ->paginate(15);

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::all();
        $books = Book::where('stock', '>', 0)->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $borrowing = Borrowing::create([
                'member_id' => $validated['member_id'],
                'borrow_date' => $validated['borrow_date'],
                'status' => 'borrowed'
            ]);

            foreach ($validated['books'] as $bookData) {
                $book = Book::find($bookData['book_id']);
                
                if ($book->stock < $bookData['quantity']) {
                    throw new \Exception("Stok buku '{$book->title}' tidak mencukupi");
                }

                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $bookData['book_id'],
                    'quantity' => $bookData['quantity']
                ]);

                $book->decrement('stock', $bookData['quantity']);
            }

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'borrowingDetails.book']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function return(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return redirect()->back()
                ->with('error', 'Buku sudah dikembalikan');
        }

        DB::beginTransaction();
        try {
            $borrowing->update([
                'status' => 'returned',
                'return_date' => now()
            ]);

            foreach ($borrowing->borrowingDetails as $detail) {
                $detail->book->increment('stock', $detail->quantity);
            }

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Buku berhasil dikembalikan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}