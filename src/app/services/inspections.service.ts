import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from "../../environments/environment";
import { Response } from "../interfaces/response";
import { AuthenticationService } from './authentication.service';
import { User } from '../interfaces/user';

@Injectable({
  providedIn: 'root'
})
export class InspectionsService {
  usuarioActual: User
  constructor(
    private http: HttpClient,
    private authService: AuthenticationService
  ) {
    this.usuarioActual = this.authService.currentUserValue
  }

  agregarInspeccion(form) {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        function: 'aggInspeccion',
        form,
        tkn: this.usuarioActual.access_token
      }
    );
  }

  getInspecciones() {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        function: 'getInspecciones',
        tkn: this.usuarioActual.access_token
      });
  }

  getInspeccionById(id) {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        function: 'getInspeccionById',
        idInspeccion: id,
        tkn: this.usuarioActual.access_token
      });
  }

  cerrarInspeccion(form, idInspeccion) {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        function: 'crrInspeccion',
        form,
        idInspeccion,
        tkn: this.usuarioActual.access_token
      }
    );
  }
}
