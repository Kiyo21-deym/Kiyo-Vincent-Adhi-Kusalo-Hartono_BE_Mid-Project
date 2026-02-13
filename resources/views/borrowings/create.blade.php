@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <h2>Peminjaman Baru</h2>
        <hr>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('borrowings.store') }}" method="POST" id="borrowingForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Anggota *</label>
                                <select 
                                    class="form-select @error('member_id') is-invalid @enderror" 
                                    id="member_id" 
                                    name="member_id" 
                                    required>
                                    <option value="">Pilih Anggota</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" 
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->member_code }} - {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="borrow_date" class="form-label">Tanggal Pinjam *</label>
                                <input type="date" 
                                    class="form-control @error('borrow_date') is-invalid @enderror" 
                                    id="borrow_date" 
                                    name="borrow_date" 
                                    value="{{ old('borrow_date', date('Y-m-d')) }}" 
                                    required>
                                @error('borrow_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5>Daftar Buku yang Dipinjam</h5>

                    <div id="booksList">
                        <div class="row book-item mb-2">
                            <div class="col-md-8">
                                <select class="form-select" name="books[0][book_id]" required>
                                    <option value="">Pilih Buku</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" data-stock="{{ $book->stock }}">
                                            {{ $book->title }} (Stok: {{ $book->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" 
                                    class="form-control" 
                                    name="books[0][quantity]" 
                                    placeholder="Jumlah"
                                    min="1"
                                    value="1"
                                    required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-book" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-sm" id="addBook">
                        <i class="fas fa-plus"></i> Tambah Buku
                    </button>

                    <hr>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Peminjaman
                        </button>
                        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let bookIndex = 1;

document.getElementById('addBook').addEventListener('click', function() {
    const booksList = document.getElementById('booksList');
    const newRow = document.querySelector('.book-item').cloneNode(true);
    
    newRow.querySelector('select').name = `books[${bookIndex}][book_id]`;
    newRow.querySelector('input').name = `books[${bookIndex}][quantity]`;
    newRow.querySelector('select').value = '';
    newRow.querySelector('input').value = '1';
    newRow.querySelector('.remove-book').disabled = false;
    
    booksList.appendChild(newRow);
    bookIndex++;
    
    attachRemoveHandler();
});

function attachRemoveHandler() {
    document.querySelectorAll('.remove-book').forEach(button => {
        button.addEventListener('click', function() {
            if (document.querySelectorAll('.book-item').length > 1) {
                this.closest('.book-item').remove();
            }
        });
    });
}

attachRemoveHandler();
</script>
@endpush