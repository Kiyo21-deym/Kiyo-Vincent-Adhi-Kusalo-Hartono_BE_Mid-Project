@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('page-title', 'Manajemen Buku')

@section('content')
<div class="content-card mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-2">
            <form action="{{ route('books.index') }}" method="GET" class="d-flex gap-2">
                <select name="category_id" class="form-select" style="width: 200px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <div class="input-group" style="width: 300px;">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>
        </div>
        
        <a href="{{ route('books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>
</div>

<!-- Books Grid -->
<div class="row g-3">
    @forelse($books as $book)
    <div class="col-md-3">
        <div class="content-card h-100">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                    class="w-100 rounded mb-3" 
                    alt="{{ $book->title }}"
                    style="height: 250px; object-fit: cover;">
            @else
                <div class="w-100 rounded mb-3 d-flex align-items-center justify-content-center" 
                    style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-book fa-4x text-white"></i>
                </div>
            @endif
            
            <h6 style="font-weight: 600; margin-bottom: 0.5rem;">{{ Str::limit($book->title, 40) }}</h6>
            <p class="text-muted small mb-2">{{ $book->author }}</p>
            
            <div class="d-flex gap-2 mb-3">
                <span class="badge bg-info">{{ $book->category->name }}</span>
                <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }}">
                    Stok: {{ $book->stock }}
                </span>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning flex-fill">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin hapus?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="content-card text-center py-5">
            <i class="fas fa-book fa-4x text-muted mb-3"></i>
            <p class="text-muted">Tidak ada buku ditemukan</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($books->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $books->withQueryString()->links() }}
</div>
@endif
@endsection