import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs/operators';
import {ActivatedRoute, Router} from '@angular/router';
import {AuthenticationService} from '../../../services/authentication.service';
import { VehiculoService } from "../../../services/vehiculo.service";
import { MatAutocomplete } from "@angular/material/autocomplete";
import {Vehiculo} from "../../../interfaces/vehiculo";

@Component({
  selector: 'app-crear',
  templateUrl: './crear.component.html',
  styleUrls: ['./crear.component.css']
})
export class CrearComponent implements OnInit {
  crearForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;
  error = '';
  filterVehiculoResults: Vehiculo[] = [];



  constructor(private formBuilder: FormBuilder,
              private route: ActivatedRoute,
              private router: Router,
              private authenticationService: AuthenticationService,
              private vehiculoService: VehiculoService) {
  }

  // getter para fácil acceso a los campos del formulario
  get f() { return this.crearForm.controls; }

  ngOnInit(): void {
    this.crearForm = this.formBuilder.group({
      nVehiculo: ['', Validators.required],
      nPlaca: ['', Validators.required],
      marcaVeh: ['', Validators.required],
      modeloVeh: ['', Validators.required],
      tipoVehiculo: ['', Validators.required],
      colorVeh: ['', Validators.required],
      tipoKilom: ['', Validators.required],
      tipoComb: ['', Validators.required],
    });

    this.f.nVehiculo.valueChanges.subscribe( filter => {
      this.vehiculoService.searchVehiculo(filter).subscribe( response => {
        this.filterVehiculoResults = response.data;
        });
    });

  }

  getVehiculoData() {
    if (this.f.nVehiculo.value !== '') {
    const nVehiculo = this.f.nVehiculo.value;
    this.vehiculoService.getVehiculoData(nVehiculo).subscribe( response => {
      const vehiculo: Vehiculo = response.data;
      this.llenarCampos(
          vehiculo.modelo.marca.descMarca,
          vehiculo.modelo.nomModelo,
          vehiculo.color,
          vehiculo.tipoKilometraje,
          vehiculo.combustible.descTipoComb,
        vehiculo.placa
        );
      });
    }
  }

  llenarCampos( marca, modelo, color, tipoKilom, tipoComb, placa) {
    this.f.marcaVeh.setValue(marca);
    this.f.modeloVeh.setValue(modelo);
    this.f.colorVeh.setValue(color);
    this.f.tipoKilom.setValue(tipoKilom);
    this.f.tipoComb.setValue(tipoComb);
    this.f.nPlaca.setValue(placa);
  }


}
