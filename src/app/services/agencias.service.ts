import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Response} from "../interfaces/response";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class AgenciasService {

  constructor(private http: HttpClient) { }

  getAgencias() {
    return this.http.get<Response>(`${environment.apiUrl}/agencias/listar`);
  }
}
