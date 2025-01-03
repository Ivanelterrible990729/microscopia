<div x-data="{ theme: localStorage.getItem('appearance-mode') || 'light' }" class="intro-x flex items-center">
    <!-- Checkbox para el switch -->
    <label class="relative flex items-center cursor-pointer">
        <input
            type="checkbox"
            class="sr-only peer"
            x-on:change="
                theme = theme === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('class', 'theme-1 ' +  theme);
                localStorage.setItem('appearance-mode', theme);
            "
            :checked="theme === 'dark'"
        />
        <!-- Fondo del switch -->
        <div class="w-16 h-8 bg-slate-400 dark:bg-slate-400 rounded-full peer-checked:bg-slate-400 transition"></div>
        <!-- El círculo del switch -->
        <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center transform transition peer-checked:translate-x-8">
            <!-- Íconos de sol y luna -->
            <span x-show="theme === 'light'" class="text-yellow-500 font-bold">
                <x-base.lucide icon="sun"/>
            </span>
            <span x-show="theme === 'dark'" class="text-blue-700 font-bold">
                <x-base.lucide icon="moon"/>
            </span>
        </div>
    </label>
</div>
