import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class CommentService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  newFromGuest(comment: any) {
    return this.http.post(`${this.api}/guest-comments`, comment);
  }

  newFromConnected(comment: any) {
    return this.http.post(`${this.api}/connected-comments`, comment);
  }
}
