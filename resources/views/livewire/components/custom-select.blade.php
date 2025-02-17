<div 
    x-data="customSelect(@entangle('selected').live, {{ json_encode($options) }}, '{{ $placeholder }}')"
    class="relative w-64"
>
    <button @click="open = !open" 
            class="w-full px-4 py-2 text-left border rounded btn btn-dark">
        <span x-text="getSelectedLabel()"></span>
    </button>

    <div x-show="open" 
        @click.outside="open = false" 
        class="absolute w-full bg-light border rounded mt-1 max-h-40 z-50">
        
        <div class="p-2 border-b">
            <input 
                x-model="search" 
                @click.stop
                type="text" 
                class="w-full px-2 py-1 border rounded text-sm focus:outline-none focus:border-blue-500"
                placeholder="Search..."
            >
        </div>

        <ul class="overflow-auto">
            <template x-for="option in filteredOptions" :key="option.value">
                <li @click="selected = option.value; open = false;"
                    :class="{'bg-dark': option.value == selected}"
                    class="p-2"
                    x-text="option.label"
                    style="cursor: pointer;"></li>
            </template>
            <li x-show="filteredOptions.length === 0" 
                class="p-2 text-gray-500 text-sm">
                No results found
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('customSelect', (selected, options, placeholder) => ({
        open: false,
        selected: selected,
        options: options,
        placeholder: placeholder,
        search: '',
        
        get filteredOptions() {
            return this.search === ''
                ? this.options
                : this.options.filter(option => 
                    option.label.toLowerCase().includes(this.search.toLowerCase())
                  );
        },

        getSelectedLabel() {
            if (!this.selected) return this.placeholder;
            const option = this.options.find(o => o.value == this.selected);
            return option ? option.label : this.placeholder;
        }
    }))
})
</script>
