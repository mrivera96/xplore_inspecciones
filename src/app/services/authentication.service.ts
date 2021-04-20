import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BehaviorSubject, Observable} from 'rxjs';
import {map} from 'rxjs/operators';

import {environment} from '../../environments/environment';
import {Usuario} from '../interfaces/usuario';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private currentUserSubject: BehaviorSubject<Usuario>;
  public currentUser: Observable<Usuario>;

  constructor(private http: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<Usuario>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): Usuario {
    return this.currentUserSubject.value;
  }

  login(nickname: string, password: string) {
    return this.http.post<any>(`${environment.apiUrl}`, {nickname, password, function:'login'})
  }


  logout() {
    return this.http.post(`${environment.apiUrl}`,{function: 'logout', tkn: this.currentUserValue.access_token})
      .pipe(map(data => {
        localStorage.removeItem('currentUser');
        this.currentUserSubject.next(null);
      }));
  }

  setCurrUser(user){
    this.currentUserSubject.next(user);
  }

}
