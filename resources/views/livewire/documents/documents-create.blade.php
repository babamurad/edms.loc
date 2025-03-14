<div>
@push('editor')
        <!-- Place the first <script> tag in your HTML's <head> -->
        <script src="https://cdn.tiny.cloud/1/qy6br6hv4eka47gk5sagtw30xm277yas11wmuvkj9n56phr7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <!-- Добавляем языковые файлы -->
        <script>
            // Настраиваем путь к языковым файлам
            tinymce.baseURL = "{{ asset('js/tinymce') }}";
        </script>
@endpush

@push('summernote')
        <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
        <script>
            tinymce.init({
                selector: '#editor',
                language: '{{ app()->getLocale() }}', // Динамически устанавливаем язык из текущей локали
                height: 600,
                plugins: [
                    // Core editing features
                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                    // Your account includes a free trial of TinyMCE premium features
                    // Try the most popular premium features until Feb 24, 2025:
                    'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                setup: function (editor) {
                    editor.on('Change', function (e) {
                        // Синхронизация данных с Livewire при каждом изменении содержимого
                        var content = editor.getContent();
                    @this.set('contentDocs', content); // Важно использовать @this.set
                    });
                },

                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),

            });
            // editor.on('Change', function (e) {
            //     setTimeout(function() {
            //         var content = editor.getContent();
            //     @this.set('contentDocs', content);
            //     }, 100); // Задержка 100 миллисекунд
            // });
        </script>
@endpush

    <div class="card">
        <div class="card-header">
            <h4 class="header-title">{{ __('Document') }}</h4>
        </div>
        <div class="card-body" x-data="{ activeTab: 'attributes', contentDocs: '' }">
            <ul class="nav nav-tabs nav-bordered mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#attributes" @click.prevent="activeTab = 'attributes'" :class="{ 'active': activeTab === 'attributes', 'nav-link': true, 'rounded-0': true }" role="tab">
                        {{ __('Attributes') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#document" @click.prevent="activeTab = 'document'" :class="{ 'active': activeTab === 'document', 'nav-link': true, 'rounded-0': true }" role="tab">
                        {{ __('Document') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" :class="{ 'active': activeTab === 'attributes' }" id="attributes" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input type="text" id="title" class="form-control" wire:model="title" wire:keyup="generateSlug()">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="slug" class="form-label">{{ __('Slug') }}</label>
                                <input type="text" id="slug" class="form-control" wire:model="slug">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="department" class="form-label">{{ __('Departments') }}</label>
                                <select class="form-select" id="department" wire:model="selectedDepartment">
                                    <option value="" selected>{{ __('Select an department') }}</option>
                                    @foreach($departments as $department)
                                        <option wire:key="{{ $department->id }}" value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('Categories') }}</label>
                                <select class="form-select" id="category" wire:model="selectedCategory">
                                    <option value="" selected>{{ __('Select an category') }}</option>
                                    @foreach($categories as $category)
                                        <option wire:key="{{ $category->id }}" value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('Statuses') }}</label>
                                <select class="form-select" id="category" wire:model="selectedStatus">
                                    <option value="" selected>{{ __('Select an status') }}</option>
                                    @foreach($statuses as $status)
                                        <option wire:key="{{ $status->id }}" value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-check form-switch my-4">
                                    <input type="checkbox" class="form-check-input" id="customSwitch1">
                                    <label class="form-check-label" for="customSwitch1">{{ __('Published') }}</label>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="tab-pane" :class="{ 'active': activeTab === 'document' }" id="document" role="tabpanel">
                    <div wire:ignore>
                        <textarea id="editor" x-model="contentDocs"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i>{{ __('Save') }}</button>
            <button type="button" class="btn btn-secondary"><i class="mdi mdi-cancel me-1"></i>{{ __('Cancel') }}</button>
        </div>
    </div>

</div>
