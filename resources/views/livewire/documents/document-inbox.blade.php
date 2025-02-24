<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                </div>
                <h4 class="page-title">Inbox</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Incoming Documents</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>From</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shares as $share)
                            <tr @class(['table-active' => !$share->read_at])>
                                <td><i class="{{ $share->document->FileIcon }} fs-4 me-1"></i>{{ $share->document->title }}</td>
                                <td>{{ $share->sender->name }}</td>
                                <td>{{ $share->message }}</td>
                                <td><span class="badge bg-{{ $share->read_at ? 'success' : 'warning' }}">
                                    {{ $share->status->name }}
                                </span></td>
                                <td>{{ $share->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ asset($share->document->ReceivedFileUrl) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-primary"
                                       wire:click="markAsRead({{ $share->id }})">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No incoming documents</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $shares->links() }}
        </div>
    </div>            
        </div>
    </div>

</div>
