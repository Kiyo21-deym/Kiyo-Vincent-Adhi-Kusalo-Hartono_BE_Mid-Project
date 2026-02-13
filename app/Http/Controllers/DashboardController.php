<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_members' => Member::count(),
            'total_categories' => Category::count(),
            'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
            'total_borrowed_books' => Borrowing::where('status', 'borrowed')
                ->with('borrowingDetails')
                ->get()
                ->sum(function($b) {
                    return $b->borrowingDetails->sum('quantity');
                }),
        ];

        $recent_borrowings = Borrowing::with(['member', 'borrowingDetails.book'])
            ->latest()
            ->take(5)
            ->get();

        $low_stock_books = Book::where('stock', '<=', 2)
            ->where('stock', '>', 0)
            ->with('category')
            ->get();

        return view('dashboard', compact('stats', 'recent_borrowings', 'low_stock_books'));
    }
}