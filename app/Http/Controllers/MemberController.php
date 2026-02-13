<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::withCount('borrowings')->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|max:15',
            'address' => 'nullable'
        ]);

        $validated['member_code'] = Member::generateMemberCode();
        $validated['join_date'] = now();

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil didaftarkan');
    }

    public function show(Member $member)
    {
        $member->load(['borrowings.borrowingDetails.book']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required|max:15',
            'address' => 'nullable'
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        $activeBorrowings = $member->borrowings()
            ->where('status', 'borrowed')
            ->count();

        if ($activeBorrowings > 0) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota tidak bisa dihapus karena masih memiliki peminjaman aktif');
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}