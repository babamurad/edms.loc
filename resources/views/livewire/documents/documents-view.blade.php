<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="header-title">{{ $document->title }}</h4>
        <div>
            <livewire:documents.document-share :document="$document" />
            <!-- другие кнопки -->
        </div>
    </div>
    <!-- остальное содержимое -->
</div>
