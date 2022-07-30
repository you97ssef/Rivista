import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-profiles',
  templateUrl: './profiles.component.html',
  styleUrls: ['./profiles.component.scss']
})
export class ProfilesComponent implements OnInit {
  profiles:any = null;

  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.userService.all().subscribe((response: any) => {
      console.log(response);
      this.profiles = response.data;
    });
  }

}
