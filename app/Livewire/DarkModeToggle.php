<?php
    namespace App\Livewire;

    use Livewire\Component;

    class DarkModeToggle extends Component
    {
        public bool $darkMode = false;

        public function mount()
        {
            $this->darkMode = session('darkMode', false);
        }

        public function toggle()
        {
            $this->darkMode = !$this->darkMode;
            session(['darkMode' => $this->darkMode]);

            $this->dispatch('dark-mode-changed', dark: $this->darkMode);
        }

        public function render()
        {
            return view('livewire.dark-mode-toggle');
        }
    };
?>
