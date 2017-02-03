@extends('layout.HUdefault')
@section('title')
    Activiteiten
@stop
@section('content')
    <div class="container-fluid">
        <script>
            $(document).ready(function() {
                // Add new resource person or material
                (function() {
                    $('#new-rp-hidden').hide();
                    $('#new-rm-hidden').hide();

                    $('[name="res_person"]').click(function() {
                        if ($('#new_rp').is(':checked')) {
                            $('#new-rp-hidden').show();
                        } else {
                            $('#new-rp-hidden').hide();
                        }
                    });

                    $('[name="res_material"]').click(function() {
                        if ($('#new_rm').is(':checked')) {
                            $('#new-rm-hidden').show();
                        } else {
                            $('#new-rm-hidden').hide();
                        }

                        if ($('#rm_none').is(':checked')) {
                            $('#res_material_detail').hide();
                        } else {
                            $('#res_material_detail').show();
                        }
                    });
                })();

                // Help Text
                (function() {
                    $("#help-text").hide();

                    $(".expand-click").click(function(){
                        $(".cond-hidden").hide();
                        $(this).siblings().show();
                        $("#cond-select-hidden").hide();
                        $("#rp_id").trigger("change");
                    });

                    $("#help-click").click(function(){
                        $('#help-text').slideToggle('slow');
                    });
                })();

                // Tooltips
                (function() {
                    $('[data-toggle="tooltip"]').tooltip();
                })();
            });
        </script>
        <div class="row">
            <div class="col-md-12 well">
                <h4 id="help-click" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i> Hoe werkt deze pagina?</h4>
                <div id="help-text">
                    <ol>
                        <li>Kies een datum waarop je de werkzaamheid hebt uitgevoerd. Deze mag alleen in het verleden of heden liggen.</li>
                        <li>Vul een omschrijving in van wat je hebt gedaan</li>
                        <li>Selecteer hoe je aan deze taak hebt gewerkt, of vul een nieuw verband toe. Heb je er alleen aan gewerkt of samen met iemand?</li>
                        <li>Selecteer de status van deze werkzaamheid. Is deze al afgerond of ben je er nog mee bezig?</li>
                        <li>Selecteer hoe moeilijk je deze taak vond. Liep je tegen problemen aan of ging het je goed af?</li>
                        <li>Klik op 'Opslaan'. De taak wordt onder in het scherm toegevoegd.</li>
                    </ol>
                </div>
            </div>
        </div>
        @if(count($errors) > 0 || session()->has('success'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-{{ (session()->has('success')) ? 'success' : 'error' }}">
                        <span>{{ Lang::get('elements.alerts.'.((session()->has('success') ? 'success' : 'error'))) }}: </span>{{ (session()->has('success')) ? session('success') : $errors->first() }}
                    </div>
                </div>
            </div>
        @endif
        {{ Form::open(array('url' => '/acting/create', 'class' => 'form-horizontal')) }}
            <div class="row well">
                <div class="col-md-2 form-group">
                    <h4>Activiteit</h4>
                    <input class="form-control fit-bs" type="date" name="date" value="{{ date('Y-m-d', strtotime("now")) }}" /><br/>
                    <h4>Omschrijving:</h4>
                    <textarea class="form-control fit-bs" name="description" required oninput="this.setCustomValidity('')" pattern="[ 0-9a-zA-Z-_,.?!*&%#()'\"]{3,80}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z-_,.?!*&%#()'\"')" rows="5" cols="19"></textarea>
                </div>
                <div class="col-md-2 form-group buttons">
                    <h4>Wanneer?</h4>
                    @foreach ($timeslots as $key => $value)
                        <label><input type="radio" name="timeslot" value="{{ $value->timeslot_id }}" {{ ($key == 0) ? "checked" : "" }} /><span>{{ $value->timeslot_text }}</span></label>
                    @endforeach
                </div>
                <div class="col-md-2 from-group buttons">
                    <h4>Met wie?</h4>
                    @foreach ($resPersons as $key => $value)
                        <label><input type="radio" name="res_person" value="{{ $value->rp_id }}" {{ ($key == 0) ? "checked" : "" }} /><span>{{ $value->person_label }}</span></label>
                    @endforeach
                    <div>
                        <label><input type="radio" name="res_person" id="new_rp" value="new"><span class="new">Anders<br />(Toevoegen)</span></label>
                        <input id="new-rp-hidden" type="text" name="new_rp" placeholder="Omschrijving" oninput="this.setCustomValidity('')" pattern="[0-9a-zA-Z ()]{1,50}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z ()')" />
                    </div>
                </div>
                <div class="col-md-2 from-group buttons">
                    <h4>Met welke theorie?</h4>
                    @foreach ($resMaterials as $key => $value)
                        <label><input type="radio" name="res_material" value="{{ $value->rm_id }}" {{ ($key == 0) ? "checked" : "" }} /><span>{{ $value->rm_label }}</span></label>
                    @endforeach
                    <label><input type="radio" name="res_material" id="rm_none" value="none"><span>Geen</span></label>
                    <input type="text" name="res_material_detail" id="res_material_detail" placeholder="Beschrijving bron" />
                    <label><input type="radio" name="res_material" id="new_rm" value="new"><span class="new">Anders<br />(Toevoegen)</span></label>
                    <input type="text" name="new_rm" id="new-rm-hidden" placeholder="Omschrijving" oninput="this.setCustomValidity('')" pattern="[0-9a-zA-Z ()]{1,50}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z ()')" />
                </div>
                <div class="col-md-2 from-group">
                    <h4>Wat heb je geleerd?<br />Wat is het gevolg?</h4>
                    <textarea class="form-control fit-bs" name="learned" required oninput="this.setCustomValidity('')" pattern="[ 0-9a-zA-Z-_,.?!*&%#()'\"]{3,80}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z-_,.?!*&%#()'\"')" rows="5" cols="19"></textarea>
                    <h4>Wat heb je hierbij nodig van je werkplek?</h4>
                    <textarea class="form-control fit-bs" name="support_wp" required oninput="this.setCustomValidity('')" pattern="[ 0-9a-zA-Z-_,.?!*&%#()'\"]{3,80}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z-_,.?!*&%#()'\"')" rows="5" cols="19"></textarea>
                    <h4>Wat heb je hierbij nodig van de HU?</h4>
                    <textarea class="form-control fit-bs" name="support_ed" required oninput="this.setCustomValidity('')" pattern="[ 0-9a-zA-Z-_,.?!*&%#()'\"]{3,80}" oninvalid="this.setCustomValidity('{{ Lang::get('elements.general.mayonlycontain') }} 0-9a-zA-Z-_,.?!*&%#()'\"')" rows="5" cols="19"></textarea>
                </div>
                <div class="col-md-2 from-group">
                    <div>
                        <h4>Leervraag</h4>
                        <select name="learning_goal">
                            @foreach ($learningGoals as $key => $value)
                                <option value="{{ $value->learninggoal_id }}">{{ $value->learninggoal_label }}</option>
                            @endforeach
                        </select>
                        <h4>Competentie</h4>
                        <select name="competence">
                            @foreach ($competencies as $value)
                                <option value="{{ $value->competence_id }}">{{ $value->competence_label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-info" style="margin: 44px 0 0 30px;" value="Save" />
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <div class="row">
            <table class="table blockTable col-md-12">
                <thead class="blue_tile">
                    <tr>
                        <td>Datum</td>
                        <td>omschrijving</td>
                        <td>Wanneer?</td>
                        <td>Met wie?</td>
                        <td>Theorie</td>
                        <td>Leerpunten en vervolg</td>
                        <td>Leervraag</td>
                        <td>Competentie</td>
                    </tr>
                </thead>
                @foreach ($activities as $key => $value)
                    <tr>
                        <td>{{ date('d-m', strtotime($value->date)) }}</td>
                        <td>{{ $value->situation }}</td>
                        <td>{{ $value->getTimeslot() }}</td>
                        <td>{{ $value->getResourcePerson() }}</td>
                        <td>{{ $value->getResourceMaterial() }}</td>
                        <td>{{ $value->lessonslearned }}</td>
                        <td>{{ $value->getLearningGoal() }}</td>
                        <td>{{ $value->getCompetencies() }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop