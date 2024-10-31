<?php

namespace App\Lib\Mechanic;

use App\Models\Mechanic;

class MechanicsAssociator {
  private $model;

  public function __construct($model) {
    $this->model = $model;
  }

  public function getMechanics() {
    $mechanicsIds = $this->model->mechanics->pluck('id');
    $mechanics = Mechanic::orderBy('name', 'asc')->get();
    $mechanicsSummary = collect([]);
    foreach ($mechanics as $mechanic) {
        $mechanicsSummary->push([
            'label' => $mechanic->name,
            'id' => $mechanic->id,
            'description' => $mechanic->description,
            'checked' => $mechanicsIds->contains($mechanic->id),
        ]);
    }
    return $mechanicsSummary;
  }

  public function saveMechanic($mechanicId, $checked) {
    $this->model->mechanics()->detach($mechanicId);
    if($checked) {
        $this->model->mechanics()->attach($mechanicId);
    }
  }
}
