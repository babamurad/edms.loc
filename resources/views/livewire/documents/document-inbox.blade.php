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
                    <!-- Добавляем панель поиска и выбора количества записей -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('Search...') }}" 
                                       wire:model.live.debounce.300ms="search">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <label class="me-2">{{ __('Documents per page') }}:</label>
                                <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Document') }}</th>
                                    <th>{{ __('From') }}</th>
                                    <th>{{ __('Message') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
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
                                            <div class="btn-group">
                                                <a href="{{ asset($share->document->ReceivedFileUrl) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-primary me-1"
                                                   wire:click="markAsRead({{ $share->id }})">
                                                    <i class="bi bi-eye"></i> {{ __('View') }}
                                                </a>
                                                <a href="{{ asset($share->document->ReceivedFileUrl) }}" 
                                                   class="btn btn-sm btn-success"
                                                   download="{{ $share->document->title }}.{{ $share->document->file_extension }}">
                                                    <i class="bi bi-download"></i> {{ __('Download') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No incoming documents') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $shares->links() }}
                    </div>
                    
                    <!-- Информация о количестве документов -->
                    <div class="text-muted text-center mt-2">
                        {{ __('Showing') }} {{ $shares->firstItem() ?? 0 }}-{{ $shares->lastItem() ?? 0 }} {{ __('of') }} {{ $shares->total() }} {{ __('documents') }}
                    </div>
                </div>
            </div>            
        </div>
    </div>

</div>
