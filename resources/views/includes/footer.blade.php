<footer  class="w-full">
    <section class="w-full">
        <div class="w-full h-auto p-3 text-center flex flex-wrap justify-center items-center">
            <div class="sm:w-full md:text-right md:w-[49%] h-[200px] min-w-[300px] inline-block h-full p-3 md:basis-[49%] sm:basis-full shrink-0">
                <nav class="p-0">
                    <ul class="font-bold  gap-y-4 w-full">
                        <li class="underline">Home</li>
                        <li class="underline">Rooms</li>
                        <li class="underline">Customer Care</li>
                    </ul>
                </nav>
            </div>
            <div class="sm:w-full md:text-left sm:text-center md:w-[49%] h-[200px] min-w-[300px] inline-block h-full p-3 md:basis-[49%] sm:basis-full shrink-0">
                <nav>
                    <ul>
                        <li>Home</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <section class="w-full text-center p-4">
        {{ config('app.name', 'HOTEL Name') }} @ {{ date("Y") }} built by <a href="https://twitter.com/codad5_">Chibueze.M.A</a>
    </section>
</footer>
