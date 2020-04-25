import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';

import {environment} from '../../environments/environment';
import {Usuario} from '../interfaces/usuario';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {

  constructor(private http: HttpClient) { }

  public getAll() {
     return this.http.get<Usuario[]>(`${environment.apiUrl}/usuarios/list`);
  }
}
