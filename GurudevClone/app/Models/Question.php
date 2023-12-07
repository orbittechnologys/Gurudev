<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = [ "tags", "question","negative_marking", "answer1", "answer2", "answer3", "answer4", "answer5", "answer6", "description", "correct_answer",'marks'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    public function questionAllocationDetail()
    {
        return $this->hasMany('App\Models\QuizDetail');
    }

    public function saveData($data)
    {

            $res = $this->insert($data);
            if ($res)
                return ['success', "Questions Added Successfully"];
            else
                return ['danger', "Invalid Field Details"];

    }

    public function edit($id)
    {
        $data = $this->find($id)->toArray();
        return $data;
    }

    public function updateQuestion($data)
    {
        if (empty($data['answer' . $data['correct']])) {
            $data['answer' . $data['correct']] = "None Of the Above";
        }
        $this->where('id', $data['id'])
            ->update(['question' => $data['question'],'tags'=>$data['tags'],
                'answer1' => $data['answer1'], 'answer2' => $data['answer2'],
                'answer3' => $data['answer3'], 'answer4' => $data['answer4'],
                'answer5' => $data['answer5'], 'answer6' => $data['answer6'],
                'description' => $data['description'],
                'negative_marking' => $data['negative_marking'],
                'marks' => $data['marks'],
                'correct_answer' => 'answer' . $data['correct'],
            ]);

        return ['success', "Question Updated Successfully"];
    }

}
