@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Daftar Anggota</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrasi Anggota Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">Kode Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th width="12%">Tanggal Gabung</th>
                    <th width="10%">Total Pinjam</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $key => $member)
                <tr>
                    <td>{{ $members->firstItem() + $key }}</td>
                    <td><span class="badge bg-secondary">{{ $member->member_code }}</span></td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->join_date->format('d M Y') }}</td>
                    <td class="text-center">
                        <span class="badge bg-info">{{ $member->borrowings_count }}</span>
                    </td>
                    <td>
                        <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data anggota</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection