<div>
    <button type="button" class="btn btn-sm btn-primary me-1" wire:click="$set('showModal', true)">
        <i class="bi bi-share"></i>
    </button>

    @if($showModal)
    {{-- <div class="modal-backdrop fade show"></div> --}}
    <div wire:ignore class="modal show" style="display: block; background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Document</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Recipients </label>
                        <select class="select2 form-control select2-multiple select2-hidden-accessible" multiple wire:model="selectedUsers" style="height: 12rem;">
                            @foreach($departments as $department)
                                @if($department->users->count() > 0)
                                    <optgroup label="{{ $department->title }}">
                                        @foreach($department->users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                        @error('selectedUsers') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message (optional)</label>
                        <textarea class="form-control" wire:model="message" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="shareDocument">Share</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('select2-css')
        <!-- Select2 css -->
        <link href="{{  asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />    
    @endpush
    
    @push('select2-js')
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
    document.addEventListener('livewire:load', function() {
        initSelect2();
        
        Livewire.hook('message.processed', (message, component) => {
            initSelect2();
        });
    });

    function initSelect2() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('.modal'),
            language: {
                searching: function() {
                    return "Поиск...";
                },
                noResults: function() {
                    return "Результатов не найдено";
                }
            },
            placeholder: 'Выберите получателей',
            allowClear: true
        }).on('change', function(e) {
            @this.set('selectedUsers', $(this).val());
        });
    }
    </script>
    @endpush
</div>
