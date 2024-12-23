<div x-data="{ theme: localStorage.getItem('appearance-mode') || 'light' }" class="intro-x flex items-center">
    <!-- Checkbox para el switch -->
    <label class="relative flex items-center cursor-pointer">
        <input
            type="checkbox"
            class="sr-only peer"
            x-on:change="
                theme = theme === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('class', theme);
                localStorage.setItem('appearance-mode', theme);
            "
            :checked="theme === 'dark'"
        />
        <!-- Fondo del switch -->
        <div class="w-16 h-8 bg-gray-200 dark:bg-gray-600 rounded-full peer-checked:bg-primary transition"></div>
        <!-- El círculo del switch -->
        <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center transform transition peer-checked:translate-x-8">
            <!-- Íconos de sol y luna -->
            <span x-show="theme === 'light'" class="text-yellow-500">☀️</span>
            <span x-show="theme === 'dark'" class="text-blue-500">🌙</span>
        </div>
    </label>
</div>
