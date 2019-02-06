import numpy as np #for mathematical operations and constants
import itertools #
from plotly.offline import download_plotlyjs,init_notebook_mode,plot,iplot #for visualisation 
import plotly.graph_objs as go #for visualisation

### FOR 3D ARROWS: 

def sp2c(r,theta,phi):
    return [r*np.sin(theta) * np.cos(phi), r*np.sin(theta) * np.sin(phi), r*np.cos(theta)]

def c2sp (x,y,z):
    if x**2+y**2+z**2 == 0: 
        return [0,0,0]
    else: 
        r = np.sqrt(x**2+y**2+z**2)
        theta = np.arccos(z/r);
        if y>=0: 
            if x==0: 
                phi = np.pi/2; 
                return [r,theta,phi]
            elif x>0: 
                    phi = np.arctan(y/x);
                    return [r,theta,phi]
            else: 
                phi = np.pi + np.arctan(y/x)
                return [r,theta,phi]
        else: 
            if x==0: 
                phi = 3*np.pi/2; 
                return [r,theta,phi]
            elif x<0: 
                phi = np.pi + np.arctan(y/x);
                return [r,theta,phi];
            else: 
                phi = 2*np.pi + np.arctan(y/x);
                return [r,theta,phi]
            
class Arrow3D():
    
    def __init__(self,cart_coords,offset,width,color,ratio,legend_status,label,fraction):
        
        self.u = cart_coords[0]
        self.v = cart_coords[1]
        self.w = cart_coords[2]
        self.offset = offset
        self.width = width
        self.color = color
        self.ratio= ratio 
        self.frac = fraction 
        
        [r,theta,phi] = c2sp (self.u,self.v,self.w)
        [wing_length,wing_angle]= self.find_wing_coordinate(r); 
        
        wings_a = np.asarray(sp2c((self.ratio*wing_length),(theta+wing_angle),phi))+np.asarray(offset)
        wings_b = np.asarray((sp2c((self.ratio*wing_length),(theta-wing_angle),phi))+np.asarray(offset))
                             
        shaft_xyz = [(self.u*self.ratio) + offset[0],(self.v*self.ratio) + offset[1], (self.w*self.ratio) + offset[2]]
        wings_xyz= [wings_a,wings_b]
    
        self.shaft = go.Scatter3d(
            x=[offset[0], shaft_xyz[0]],
            y=[offset[1], shaft_xyz[1]],
            z=[offset[2], shaft_xyz[2]],
            name = label,
            showlegend=legend_status, mode='lines', line={'width': self.width, 'color': self.color}
        )
    
        self.wings = go.Scatter3d(
            x=[wings_xyz[0][0], shaft_xyz[0], wings_xyz[1][0]],
            y=[wings_xyz[0][1], shaft_xyz[1], wings_xyz[1][1]],
            z=[wings_xyz[0][2], shaft_xyz[2], wings_xyz[1][2]],
            showlegend=False, mode='lines', line={'width': self.width, 'color': self.color}
        )

        self.data = [self.shaft, self.wings]
    
    def find_wing_coordinate(self,r): 
        frac = self.frac*r; 
        d = r - frac*np.sin(np.pi/4);
        a = np.sqrt((frac*np.sin(np.pi/4))**2 + d**2)
        alpha = np.arccos(d/a)
        return [a,alpha]

### FOR 2D ARROWS: 

def p2c(rho,phi): 
    return [rho*np.cos(phi),rho*np.sin(phi)]

def c2p (x,y): 
    if x**2 + y**2 ==0: 
        return [0,0]
    else: 
        rho = np.sqrt(x**2+y**2)
        if y>=0: 
            if x==0: 
                phi = np.pi/2; 
                return [rho,phi]
            elif x>0: 
                phi = np.arctan(y/x)
                return [rho,phi]
            else: 
                phi = np.pi + np.arctan(y/x)
                return [rho,phi]
        else:
            if x==0: 
                phi = 3*np.pi/2; 
                return [rho,phi]
            elif x<0: 
                phi = np.pi + np.arctan(y/x); 
                return [rho,phi]
            else: 
                phi = 2*np.pi + np.arctan(y/x); 
                return [rho,phi]

class Arrow2D():
    
    def __init__(self,cart_coords,offset,width,ratio,color,legend_status,label):
        
        self.u = cart_coords[0]
        self.v = cart_coords[1]
        self.offset = offset
        self.width = width
        self.color = color
        self.ratio= ratio  
        
        [r,phi] = c2p(self.u,self.v)
        [wing_length,wing_angle] = self.find_wing_coord(r); 
    
        wings_a = np.asarray(p2c((self.ratio*wing_length),(wing_angle+phi)))+ np.asarray(offset)
        wings_b = np.asarray(p2c((self.ratio*wing_length),(phi-wing_angle))) + np.asarray(offset) 
        
        shaft_xy = [(self.u*self.ratio)+offset[0],(self.v*self.ratio)+offset[1]]
        wings_xy = [wings_a,wings_b]
    
        self.shaft = go.Scatter3d(
            x=[offset[0], shaft_xy[0]],
            y=[offset[1], shaft_xy[1]],
            z = [0,0],
            name = label, 
            showlegend = legend_status,
            mode='lines', line={'width': self.width, 'color': self.color}
        )
    
        self.wings = go.Scatter3d(
            x=[wings_xy[0][0], shaft_xy[0], wings_xy[1][0]],
            y=[wings_xy[0][1], shaft_xy[1], wings_xy[1][1]],
            z = [0,0,0],
            showlegend=False, mode='lines', line={'width': self.width, 'color': self.color}
        )

        self.data = [self.shaft, self.wings]
    
    def find_wing_coord(self,r): 
        frac = 0.2*r; 
        sin45 = np.sin(np.pi/4);
        d = r - frac * sin45; 
        a = np.sqrt((frac*sin45)**2 + d**2);
        alpha = np.arccos(d/a)
        return [a,alpha]
        
    
        