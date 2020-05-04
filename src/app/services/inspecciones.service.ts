import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from "../../environments/environment";
import {Response} from "../interfaces/response";

@Injectable({
  providedIn: 'root'
})
export class InspeccionesService {

  constructor(
    private http: HttpClient
  ) { }

  agregarInspeccion(form) {
    return this.http.post<Response>(`${environment.apiUrl}/inspecciones/agregar`, form);
  }

  getInspecciones() {
    return this.http.get<Response>(`${environment.apiUrl}/inspecciones/listar`);
  }

  getInspeccionById(id){
    return this.http.get<Response>(`${environment.apiUrl}/inspecciones/getById`, { params: { idInspeccion: id } } );
  }
}
