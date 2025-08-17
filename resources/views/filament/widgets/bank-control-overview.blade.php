<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-4 gap-4">

            @foreach($banks as $bank)
                <div class="shadow rounded-lg flex flex-col gap-2 p-4" style="background-color: {{ $bank['color'] }}">

                    {{-- <div class="w-10 h-10 rounded-full overflow-hidden flex justify-center items-center bg-white/50 p-2">
                        <img src="https://sisdespesas.fabiomelodev.com.br/uploads/images/01K2GJHRWD5DKTCYP3NBMZBQ4X.png" alt="NuBank">
                    </div> --}}

                    <p class="text-lg font-bold text-white">
                        {{ $bank['title'] }}
                    </p>

                    <div>
                        <p class="text-3xl font-bold text-white">
                            {{ $bank['remainingTotalValue'] }}
                        </p>
                    </div>

                    <div class="flex justify-between gap-2">
                        <p class="text-xs font-medium text-white/50">
                            Entrada <br>
                            <span class="text-sm font-bold text-white">
                                {{ $bank['depositsTotalValue']}}
                            </span>
                        </p>

                        <p class="text-xs font-medium text-white/50">
                            Saída <br>
                            <span class="text-sm font-bold text-white">
                                {{ $bank['expensesTotalValue'] }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
