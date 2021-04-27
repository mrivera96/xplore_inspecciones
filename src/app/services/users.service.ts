import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../environments/environment';
import { User } from '../interfaces/user';
import { AuthenticationService } from './authentication.service';

@Injectable({
  providedIn: 'root'
})
export class UsersService {
  usuarioActual: User
  constructor(private http: HttpClient,
    private authService: AuthenticationService) {
    this.usuarioActual = this.authService.currentUserValue
  }

  public getAll() {
    return this.http.post<User[]>(`${environment.apiUrl}`, {
      function: 'getUsuarios',
      tkn: this.usuarioActual.access_token
    });
  }
}
