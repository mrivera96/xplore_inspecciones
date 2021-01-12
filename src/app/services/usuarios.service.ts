import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../environments/environment';
import { Usuario } from '../interfaces/usuario';
import { AuthenticationService } from './authentication.service';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {
  usuarioActual: Usuario
  constructor(private http: HttpClient,
    private authService: AuthenticationService) {
    this.usuarioActual = this.authService.currentUserValue
  }

  public getAll() {
    return this.http.post<Usuario[]>(`${environment.apiUrl}`, {
      function: 'getUsuarios',
      tkn: this.usuarioActual.access_token
    });
  }
}
