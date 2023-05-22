<x-app-layout>
    <div>
        <h1 class="my-5 text-3xl text-center">Select your plan</h1>
        <div class="flex">
            <div class="w-1/12"></div>
            <div class="w-5/12 mr-2 border rounded border-indigo-500">
                <h2 class="text-center text-xl font-bold uppercase my-5">Single plan</h2>
                <div class="px-5 text-center">
                    <h3>49 <sup>00</sup> лв.</h3>
                    <ul>
                        <li>Достъп до всички въпроси</li>
                        <li>Различни типове тестове</li>
                        <li>Алгоритъм подпомагане на вземане на теста</li>
                        <li>30 дневен достъп до теста</li>
                    </ul>
                </div>
                <div class="text-center m-3">
                    <a href="{{route('checkout', ['plan'=>'single'])}}">
                        <x-primary-button>Select plan</x-primary-button>
                    </a>
                </div>
            </div>
            <div class="w-5/12 ml-2 border rounded border-indigo-500">
                <h2 class="text-center text-xl font-bold uppercase my-5">Multi-user plan</h2>
                <div class="text-center px-5">
                    <h3>39 <sup>00</sup> лв. / на потребител</h3>
                    <ul>
                        <li>Всичко от единичния план</li>
                        <li>Възможност за следене на прогреса на курсистите</li>
                    </ul>
                    <small>* планът се прилага само за обучаващи организации</small>
                </div>
                <div class="text-center m-3">
                    <a href="{{route('checkout', ['plan' => 'multi-user'])}}">
                        <x-primary-button>Select plan</x-primary-button>
                    </a>
                </div>
            </div>
            <div class="w-1/12"></div>
        </div>
    </div>
</x-app-layout>
