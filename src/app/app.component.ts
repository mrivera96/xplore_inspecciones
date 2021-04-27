import { Component } from '@angular/core';
import { Router } from '@angular/router';

import { AuthenticationService } from './services/authentication.service';
import { User } from './interfaces/user';
declare var $: any
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  currentUser: User;
  title = 'inspecciones';

  constructor(
    private router: Router,
    private authenticationService: AuthenticationService
  ) {
    this.authenticationService.currentUser.subscribe(x => this.currentUser = x)
  }

  logout() {

    this.authenticationService.logout().subscribe(data => {
      location.reload(true)
      if ($('#sidenav').hasClass('active')) {
        $('#sidenav').toggleClass('active')
      }
    })
  }

  showLogout() {
    $('#xploreUsrSubMenu').toggleClass('d-none')
  }
}
