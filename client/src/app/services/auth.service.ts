import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  saveCredentials(response: any) {
    localStorage.setItem('token', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));

    return response;
  }

  login(user: any) {
    return this.http.post(this.api + '/login', user).pipe(
      map((response: any) => {
        this.saveCredentials(response);
      })
    );
  }

  register(user: any) {
    return this.http.post(this.api + '/register', user).pipe(
      map((response: any) => {
        this.saveCredentials(response);
      })
    );
  }

  isAuthenticated() {
    return localStorage.getItem('token') !== null;
  }

  logout() {
    return this.http.delete(this.api + '/logout').pipe(
      map((response: any) => {
        localStorage.clear();

        return response;
      })
    );
  }

  sendEmailVerification() {
    return this.http.post(this.api + '/send-verification-email', {});
  }

  verifyEmail(verify_url: string) {
    return this.http.get(verify_url);
  }

  getUser() {
    return JSON.parse(localStorage.getItem('user')!);
  }

  setUser(user: any) {
    localStorage.setItem('user', JSON.stringify(user));
  }
}
