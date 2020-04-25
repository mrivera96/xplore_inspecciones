import { Injectable } from '@angular/core';
import { Vehiculo } from "../interfaces/vehiculo";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Usuario} from "../interfaces/usuario";
import {environment} from "../../environments/environment";
import {Observable} from "rxjs";
import {Response} from "../interfaces/response";

@Injectable({
  providedIn: 'root'
})
export class VehiculoService {

  constructor(
    private http: HttpClient
  ) { }

  public searchVehiculo(busqueda: string) {
    return this.http.get<Response>(`${environment.apiUrl}/vehiculos/search` , { params: { busqueda} });
  }

  public getVehiculoData(nVehiculo: string) {
    return this.http.get<Response>(`${environment.apiUrl}/vehiculos/getData` , {params: {nemVehiculo: nVehiculo}});
  }
}
