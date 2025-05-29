<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
   
        User::create([
            'first_name'    => 'Admin',
            'last_name'     => 'Główny',
            'email'         => 'admin@admin.pl',
            'password'      => bcrypt('admin'),
            'is_admin'      => true,
        ]);
    
   
        User::factory(20)->create();
    
      
        $userIds = User::pluck('id')->all();
    
      
        $questions = [
            "Jaki jest Twój ulubiony kolor?" => ['Czerwony', 'Niebieski'],
            "Jak często uprawiasz sport?"    => ['Codziennie', 'Nigdy'],
            "Czy lubisz kawę czy herbatę?"   => ['Kawa', 'Herbata'],
            "Czy pracujesz zdalnie?"         => ['Tak', 'Nie'],
            "Czy masz zwierzęta domowe?"     => ['Tak', 'Nie'],
        ];
    
        foreach (range(1, 10) as $i) {
          
            $userId = $userIds[array_rand($userIds)];
         
            $pickedTitle = array_rand($questions); 
    
            
            $survey = Survey::create([
                'user_id'     => $userId,
                'uuid'        => \Illuminate\Support\Str::uuid(),
                'title'       => $pickedTitle,
                'description' => 'Ankieta testowa',
                'is_public'   => true,
                'is_named'    => false
            ]);
    
       
            $question = $survey->questions()->create([
                'question_text'  => $survey->title,
                'question_type'  => 'single',
                'question_order' => 1,
            ]);
    
   
            foreach ($questions[$pickedTitle] as $k => $opt) {
                $question->options()->create([
                    'option_text'  => $opt,
                    'option_order' => $k + 1
                ]);
            }
        }
    }
}