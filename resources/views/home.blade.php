@extends('layouts.app')

@section('content')
<!-- HERO -->
<section class="bg-violet-50/70">
    <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between px-6 pt-14 pb-6 md:py-20">
        <div class="md:w-1/2 lg:w-5/12 animate-fadeInLeft">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">Darmowy kreator ankiet</h1>
            <a href="{{url('/dashboard')}}" class="inline-block bg-violet-700 hover:bg-violet-800 text-white text-lg px-8 py-4 rounded-lg font-bold shadow transition transform hover:scale-105 animate-bounce-slow">Utwórz ankietę</a>
        </div>
        <div class="md:w-1/2 lg:w-7/12 flex justify-center mb-10 md:mb-0 animate-fadeInRight">
            <img class="w-[340px] md:w-[400px] rounded-3xl shadow-lg transition-transform duration-300 hover:scale-105" src="https://www.si-consulting.pl/sites/default/files/2024-09/Home_260924.png" alt="Laptop" />
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="w-full bg-white py-12">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-around items-center gap-10 px-3 animate-fadeInUp">
        <div class="flex flex-col items-center text-center group transition">
            <img class="w-12 h-12 mb-3 group-hover:scale-110 transition-transform" src="https://img.icons8.com/ios-glyphs/48/9147ff/group.png" alt="group work" />
            <span class="font-semibold">Tworzenie ankiet</span>
        </div>
        <div class="flex flex-col items-center text-center group transition">
            <img class="w-12 h-12 mb-3 group-hover:scale-110 transition-transform" src="https://img.icons8.com/ios-glyphs/48/9147ff/group.png" alt="group work" />
            <span class="font-semibold">Możliwość anonimowego głosowania</span>
        </div>
    </div>
</section>

<!-- ABOUT / DESCRIPTION -->
<section class="max-w-3xl mx-auto py-10 px-5 text-gray-800 text-xl animate-fadeInUp">
    Odkryj najprostszy sposób na tworzenie formularzy ankietowych — drukowanych lub cyfrowych.
    Dzięki naszemu portalowi szybko wygenerujesz ankiety z właściwymi pytaniami i uzyskasz potrzebne dane.
</section>

<!-- Custom Animations -->
<style>
@keyframes fadeInLeft {
  0% { opacity: 0; transform: translateX(-40px);}
  100% { opacity: 1; transform: none;}
}
@keyframes fadeInRight {
  0% { opacity: 0; transform: translateX(40px);}
  100% { opacity: 1; transform: none;}
}
@keyframes fadeInUp {
  0% { opacity:0; transform: translateY(50px);}
  100% { opacity:1; transform: none;}
}
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0);}
  50% { transform: translateY(-8px);}
}
.animate-fadeInLeft { animation: fadeInLeft 1s cubic-bezier(0.49, 0.22, 0.65, 1) 0.2s both;}
.animate-fadeInRight { animation: fadeInRight 1s cubic-bezier(0.49, 0.22, 0.65, 1) 0.3s both;}
.animate-fadeInUp { animation: fadeInUp 1.1s cubic-bezier(0.49, 0.22, 0.65, 1) 0.3s both;}
.animate-bounce-slow { animation: bounce-slow 3s infinite;}
</style>
@endsection