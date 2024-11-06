<?php

namespace App\Livewire;

use App\Models\Incidence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class IncidencesTable extends PowerGridComponent
{
    public string $tableName = 'incidences-table-0ezysp-table';

    public function setUp(): array
    {

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return Incidence::query();
        } elseif ($user->hasRole('support')) {
            return Incidence::where('user_id', $user->id);
        }

        return Incidence::whereRaw('0=1');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('title')
            ->add('description', function ($incidence){
                return substr($incidence->description, 0, 50). '...';
            })
            ->add('status')
            ->add('status_label', function (Incidence $model) {
                return match ($model->status) {
                    'todo' => 'To Do',
                    'doing' => 'Doing',
                    'done' => 'Done',
                    default => ucfirst($model->status),
                };
            })
            ->add('user_name', fn(Incidence $model) => $model->user ? $model->user->name : 'No user')
            ->add('created_at')
            ->add('created_at_formatted', fn(Incidence $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('TITLE', 'title')
                ->searchable()
                ->sortable(),

            Column::make('DESCRIPTION', 'description')
                ->searchable(),

            Column::make('STATUS', 'status_label'),

            Column::make('USER', 'user_name'),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('title')->operators(['contains']),

            Filter::select('status_label', 'status')
            ->dataSource([
                ['id' => 'todo', 'name' => 'To Do'],
                ['id' => 'doing', 'name' => 'Doing'],
                ['id' => 'done', 'name' => 'Done'],
            ])
            ->optionValue('id')
            ->optionLabel('name')
        ];
    }


    #[\Livewire\Attributes\On('show')]
    public function show($rowId): void
    {
        redirect()->route('incidences.show', ['id' => $rowId]);
    }

    public function actions(Incidence $row): array
    {
        return [
            Button::add('show')
                ->slot('Show')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('show', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules(Incidence $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
